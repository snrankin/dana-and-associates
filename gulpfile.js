/** ============================================================================
 * File: /gulpfile.js
 * Project: Maat Legal Theme
 * -----
 * Author: Sam Rankin (sam@maatlegal.com>)
 * Copyright (c) 2019 Maat Legal
 * -----
 * Created Date:  1-16-19
 * Last Modified: 6-27-19 at 11:14 am
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 ** Implements:
 *   1. Live reloads browser with BrowserSync.
 *   2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps,
 *      CSS minification, and Merge Media Queries.
 *   3. JS: Concatenates & uglifies Vendor and Custom JS files.
 *   4. Images: Minifies PNG, JPEG, GIF and SVG images.
 *   5. Watches files for changes in CSS or JS.
 *   6. Watches files for changes in PHP.
 *   7. Corrects the line endings.
 *   8. InjectCSS instead of browser page reload.
============================================================================= */

// ========================================================================== //
// ============================= SECTION: Global ============================ //
// ========================================================================== //

    // --------------------------- SECTION: Config -------------------------- //
        // ====================== SECTION: Environment ====================== //
            const
                pkg       = require('./package.json'),
                gulpEnv   = pkg.env,
                gulpSlug  = pkg.name + '-';

            let gulpUrl;

            const
                devUrl    = pkg.urls.dev,
                stageUrl  = pkg.urls.stage,
                prodUrl   = pkg.urls.prod;
            let isProd    = false;

            if (gulpEnv === 'prod') {
                gulpUrl = prodUrl;
                isProd  = true;
            } else if (gulpEnv === 'stage') {
                gulpUrl = stageUrl;
            } else {
                gulpUrl = devUrl;
            }

        // !SECTION: Environment
        // ===================== SECTION: Plugin Config ===================== //

            const
                globalNode    = pkg.globalNode,
                modernizrpkg  = pkg.modernizr,
                browserlist   = pkg.browserslist,
                babelConfig   = pkg.babel,
                jshintpkg     = pkg.jshintConfig;

        // !SECTION: Plugin Config
        // ========================= SECTION: Paths ========================= //
            const
                paths             = pkg.paths,
                fontsPath         = paths.fonts,
                pagesPath         = paths.pages,
                adminPath         = paths.admin,
                componentsPath    = paths.components,
                stylesBuildPath   = paths.build.styles,
                scriptsBuildPath  = paths.build.scripts,
                stylesDistPath    = paths.dist.styles,
                scriptsDistPath   = paths.dist.scripts,
                imagesDistPath    = paths.dist.images;

        // !SECTION: Paths
        // ========================= SECTION: Files ========================= //
            const
                input           = pkg.inputFiles,
                mainSassFiles   = input.sass.main,
                adminSassFiles  = input.sass.admin,
                pageSassFiles   = input.sass.pages,
                mainJSFiles     = input.js.main,
                adminJSFiles    = input.js.admin,
                vendorJSFiles   = input.js.vendor,
                pageJSFiles     = input.js.pages,
                imageFiles      = input.images,
                fontFiles       = input.fonts;

        // !SECTION: Files
    // !SECTION: Config
    // -------------------------- SECTION: Plugins -------------------------- //
        const {
            gulp,
            series,
            parallel,
            task,
            src,
            dest,
            lastRun,
            watch
        } = require('gulp');

        const
            _           = require('lodash'),
            debug       = require('gulp-debug'),
            c           = require('ansi-colors'),
            filter      = require('gulp-filter'),
            lineec      = require('gulp-line-ending-corrector'),
            log         = require('fancy-log'),
            newer       = require('gulp-newer'),
            notify      = require('gulp-notify'),
            plumber     = require('gulp-plumber'),
            rename      = require('gulp-rename'),
            gif         = require('gulp-if'),
            lazypipe    = require('lazypipe'),
            inlineFonts = require('gulp-inline-fonts'),
            inject      = require('gulp-inject-string'),
            beautify    = require('gulp-beautify'),
            groupConcat = require('gulp-concat-multi'),
            sourcemaps  = require('gulp-sourcemaps'),
            changed     = require('gulp-changed'),
            through     = require('through2'),
            merge       = require('merge-stream'),
            mapFilter   = ['!**/*.map'],
            path        = require('path'),
            newy        = require('gulp-newy'),
            addsrc      = require('gulp-add-src');

            c.theme({
                danger    : c.red,
                dark      : c.dim.gray,
                disabled  : c.gray,
                em        : c.italic,
                heading   : c.bold.underline,
                info      : c.cyan,
                muted     : c.dim,
                primary   : c.blue,
                strong    : c.bold,
                success   : c.green,
                underline : c.underline,
                warning   : c.yellow
            });

    // !SECTION: Plugins
    // --------------------------- SECTION: Tasks --------------------------- //
        const
            fileRename      = lazypipe()
                .pipe(
                    rename,
                    function(path) {
                        var dir = path.basename;
                        var type = path.extname.replace('.', '');
                        if (dir === 'admin' || dir === 'editor') {
                            path.dirname = '/assets/' + type;
                        } else if (path.dirname.includes('pages')) {
                            path.dirname =
                                dir + '/assets/' + type;
                        } else {
                            path.dirname = '';
                        }
                    }
                )
                .pipe(
                    rename,
                    {
                        prefix: gulpSlug
                    }
                ),
            onSuccess       = lazypipe()
                .pipe(
                    notify,
                    {
                        message: "Successfully Generated file: <%= file.basename %>"
                    }
                ),
            errorMsg = _.template(`${c.red.heading('New Error In: <%= plugin %>')}\n\t   ${c.red.bold('File   :')} <%= file %>\n\t   ${c.red.bold('Line   :')} <%= line %>\n\t   ${c.red.bold('Column :')} <%= column %>\n\t   ${c.red.bold('Message:')} <%= message %>`),
            errorOpts = function (err) {
                log.error(errorMsg({
                    'plugin': err.plugin,
                    'file': err.relativePath,
                    'line': err.line,
                    'column': err.column,
                    'message': err.messageOriginal
                }));
                notify.onError({
                    logLevel: 0,
                    title: 'Error In ' + err.plugin,
                    subtitle: err.relativePath,
                    message: err.messageOriginal.toString()
                })(err);
            };

        function checkFile(projectDir, srcFile, absSrcFile) {
            var fileType = path.extname(srcFile),
                base = path.basename(srcFile, fileType),
                file = (fileType === '.scss') ? '.css' : fileType,
                fileExt = file.replace('.', ''),
                dir = '/assets/' + fileExt,
                dest = dir,
                name = base;

                if (absSrcFile.includes('admin')) {
                    pathAdmin = path.normalize(adminPath);
                    dest = path.join(pathAdmin, dir);
                } else if (absSrcFile.includes('pages')) {
                    pathPages = path.normalize(pagesPath);
                    dest = path.join(pathPages, base, dir);
                } else if (absSrcFile.includes('vendor')) {
                    name ='vendor';
                } else {
                    name = 'main';
                }

            var final = gulpSlug + name + file;

            var destinationFile = path.join(projectDir, dest, final);
            // console.log('Input File: ' + srcFile);
            // console.log('Output File: ' + final);
            // console.log('Destination: ' + dest);
            return destinationFile;
        }
        notify.logLevel(0);
    // !SECTION: Tasks

// !SECTION: Global

// ========================================================================== //
// ========================== SECTION: Browser Sync ========================= //
// ========================================================================== //

    // -------------------------- SECTION: Plugins -------------------------- //
        const browsersync = require('browser-sync').create();
    // !SECTION: Plugins
    // --------------------------- SECTION: Tasks --------------------------- //
        function browserSync() {
            browsersync.init({
                files: [
                    {
                        match: [
                            './assets/css/*.css',
                            './assets/js/*.js',
                            './assets/imgs/*',
                            './inc/pages/**/assets/css/*.css',
                            './inc/pages/**/assets/js/*.js',
                            '**/*.php'
                        ]
                    }
                ],
                ignore: ['**/*.min.*', '**/*.map', 'node_modules/**', './inc/admin/**'],
                proxy: gulpUrl,
                open: true,
                watch: true,
                injectChanges: true,
                logFileChanges: true,
                ui: false,
                notify: true
            });
        }

        function browserSyncStyleGuide() {
            browsersync.init({
                watch: true,
                files: [
                    {
                        match: [
                            './assets/css/*.css',
                            './assets/js/*.js',
                            './assets/imgs/*',
                            './style-guide.html'
                        ]
                    }
                ],
                server: {
                    baseDir: './',
                    index: 'style-guide.html'
                },
                ignore: ['**/*.min.*', '**/*.map', 'node_modules/**', './inc/admin/**'],
                open: true,
                injectChanges: true,
                logFileChanges: true
            });
        }

        function bsreload(done) {
            browsersync.reload();
            done();
        }

        exports.bs        = browserSync;
        exports.bsStyle   = browserSyncStyleGuide;
        exports.bsreload  = bsreload;

    // !SECTION: Tasks //

// !SECTION: Browsersync

// ========================================================================== //
// ============================== SECTION: CSS ============================== //
// ========================================================================== //

    // -------------------------- SECTION: PLUGINS -------------------------- //
        const
            sass            = require('gulp-sass'),
            autoprefixer    = require('autoprefixer'),
            mmq             = require('css-mqpacker'),
            sortCSSmq       = require('sort-css-media-queries'),
            postcss         = require('gulp-postcss'),
            assets          = require('postcss-assets'),
            easings         = require('postcss-easings'),
            inlineSVG       = require('postcss-inline-svg'),
            fixes           = require('postcss-fixes'),
            letterSpacing   = require('postcss-letter-tracking'),
            momentum        = require('postcss-momentum-scrolling'),
            globImporter    = require('node-sass-glob-importer'),
            cleanCSS        = require('gulp-clean-css'),
            fontMagician    = require('postcss-font-magician'),
            smoothGradients = require('postcss-easing-gradients'),
            filterGradient  = require('postcss-filter-gradient'),
            criticalCSS     = require('postcss-critical-css'),
            aspectRatio     = require('postcss-aspect-ratio-mini'),
            compileCSS      = lazypipe()
                .pipe(
                    sass,
                    {
                        errLogToConsole: true,
                        precision: 10,
                        importer: globImporter(),
                        includePaths: [
                            globalNode,
                            adminPath,
                            pagesPath,
                            componentsPath,
                            stylesBuildPath
                        ]
                    }
                )
                .pipe(
                    postcss,
                    [
                        inlineSVG({
                            path: imagesDistPath
                        }),
                        assets({
                            relative: stylesDistPath,
                            loadPaths: [fontsPath, imagesDistPath]
                        }),
                        mmq({
                            sort: sortCSSmq
                        }),
                        aspectRatio(),
                        easings(),
                        smoothGradients(),
                        filterGradient({ skipWarnings: true}),
                        letterSpacing(),
                        momentum(),
                        fixes(),
                        autoprefixer(),
                        criticalCSS({
                            outputPath: stylesDistPath,
                            outputDest: gulpSlug + 'critical.css',
                            minify: false
                        })
                    ]
                )
                .pipe(lineec),
            beautifyCSS     = lazypipe()
                .pipe(
                    cleanCSS,
                    {
                        format: 'beautify',
                        compatibility: '*',
                        level: 2,
                        debug: true,
                        inline: ['all']
                    }
                )
                .pipe(
                    beautify.css,
                    {
                        indent_size: 4
                    }
                )
                .pipe(sourcemaps.write),
            minifyCSS       = lazypipe()
                .pipe(
                    rename,
                    { suffix: '.min' }
                )
                .pipe(
                    cleanCSS,
                    {
                        compatibility: '*',
                        level: 2,
                        sourceMap: true,
                        debug: true,
                        specialComments: 'none'
                    }
                )
                .pipe(sourcemaps.write, '.'),
            mainSASS        = './build/sass/main.scss',
            adminSASS       = ['./inc/admin/build/sass/*.scss'];


    // !SECTION: Plugins
    // --------------------------- SECTION: Tasks --------------------------- //
        function compileStyles(files, fileDest, minify = isProd, isMain = false, isAdmin = false) {
            return src(files, {
                allowEmpty: true,
                base: './'
            })
            .pipe(plumber({
                errorHandler: errorOpts
            }))
            .pipe(newy(checkFile))
            .pipe(sourcemaps.init({ loadMaps: true }))
            .pipe(gif(isMain, src(mainSASS)))
            .pipe(gif(isAdmin, src(adminSASS)))
            .pipe(compileCSS())
            .pipe(fileRename())
            .pipe(beautifyCSS())
            .pipe(dest(fileDest))
            .pipe(gif(minify, minifyCSS()))
            .pipe(gif(minify, dest(fileDest)))
            .pipe(onSuccess());
        }

        function fontStyles() {
            var fontStream = merge();

            ['Dana'].forEach(
                function(name) {
                    fontStream.add(
                        src(fontsPath + '/' + `${name}` + '/*', {
                            allowEmpty: true,
                            base: './'
                        }).pipe(
                            inlineFonts({
                                name: `${name}`,
                                formats: ['eot', 'woff2', 'woff', 'ttf', 'svg']
                            })
                        )
                    );
                }
            );

            return fontStream
                .pipe(plumber({
                    errorHandler: errorOpts
                }))
                .pipe(sourcemaps.init({ loadMaps: true }))
                .pipe(sourcemaps.identityMap())
                .pipe(concat(gulpSlug + 'icons.css'))
                .pipe(gif(isProd, minifyCSS()))
                .pipe(gif(isProd, dest(stylesDistPath)))
                .pipe(onSuccess());
        }

        function mainStyles(done) {
            compileStyles(mainSassFiles, stylesDistPath, isProd, true);
            done();
        }

        function adminStyles(done) {
            compileStyles(adminSassFiles, adminPath, isProd, false, true);
            done();
        }

        function pageStyles(done) {
            compileStyles(pageSassFiles, pagesPath);
            done();
        }
        exports.fontStyles  = fontStyles;
        exports.mainStyles  = mainStyles;
        exports.adminStyles = adminStyles;
        exports.pageStyles  = pageStyles;
        exports.styles      = parallel(mainStyles, adminStyles, pageStyles);
    // !SECTION: Tasks

// !SECTION: CSS

// ========================================================================== //
// =============================== SECTION: JS ============================== //
// ========================================================================== //

    // -------------------------- SECTION: Plugins -------------------------- //
        const
            uglify            = require('gulp-uglify'),
            concat            = require('gulp-concat'),
            babel             = require('gulp-babel'),
            jshint            = require('gulp-jshint'),
            modernizr         = require('gulp-modernizr-build');
            jshintpkg.lookup  = false;

    // !SECTION: Plugins
    // ------------------------- SECTION: Variables ------------------------- //
        const
            beautifyJSOpts = {
                indent_size               : '4',
                indent_char               : ' ',
                max_preserve_newlines     : '-1',
                preserve_newlines         : false,
                keep_array_indentation    : true,
                break_chained_methods     : false,
                indent_scripts            : 'normal',
                brace_style               : 'collapse',
                space_before_conditional  : true,
                unescape_strings          : false,
                jslint_happy              : true,
                end_with_newline          : false,
                wrap_line_length          : '0',
                indent_inner_html         : false,
                comma_first               : false,
                e4x                       : false,
                indent_empty_lines        : true
            },
            jsCompile = lazypipe()
                .pipe(babel, babelConfig)
                .pipe(jshint, jshintpkg)
                .pipe(jshint.reporter, 'jshint-stylish'),
            minifyJS = lazypipe()
                .pipe(
                    rename, {
                        suffix: '.min'
                    }
                )
                .pipe(uglify);
    // !SECTION: Variables
    // --------------------------- SECTION: Tasks --------------------------- //
        // ======================= SECTION: Compile JS ====================== //
            function compileJS(files, fileDest, fileBase = '', compile = false, minify = isProd, concatFiles = true, checkFiles = false) {
                return src(files, {
                    allowEmpty: true,
                    base: './'
                })
                .pipe(plumber({
                    errorHandler: errorOpts
                }))
                .pipe(gif(checkFiles, newy(checkFile)))
                    .pipe(sourcemaps.init({ loadMaps: true }))
                .pipe(sourcemaps.identityMap())
                .pipe(gif(compile, jsCompile()))
                .pipe(gif(concatFiles, concat(fileBase + '.js')))
                .pipe(fileRename())
                .pipe(beautify.js(beautifyJSOpts))
                .pipe(dest(fileDest))
                .pipe(gif(minify, minifyJS()))
                .pipe(gif(minify, sourcemaps.write('.')))
                .pipe(gif(minify, dest(fileDest)))
                .pipe(onSuccess());
            }
        // !SECTION: Compile JS
        // ======================= SECTION: Combine JS ====================== //
            function combineJS(files, fileDest, fileBase = '', minify = isProd) {
                return src(files, {
                    allowEmpty: true,
                    base: './'
                })
                .pipe(plumber({
                    errorHandler: errorOpts
                }))
                    .pipe(sourcemaps.init({ loadMaps: true }))
                .pipe(sourcemaps.identityMap())
                .pipe(concat(fileBase + '.js'))
                .pipe(fileRename())
                .pipe(dest(fileDest))
                .pipe(gif(minify, minifyJS()))
                .pipe(gif(minify, sourcemaps.write('.')))
                .pipe(gif(minify, dest(fileDest)))
                .pipe(onSuccess());
            }
        // !SECTION: Combine JS
        // ======================= SECTION: Vendor JS ======================= //
            // ----------------- SECTION: Compile Modernizer ---------------- //
                function compileModernizr() {
                    return src(
                        [
                            pageJSFiles,
                            './inc/pages/**/assets/css/*.css',
                            './build/js/**/*.js',
                            stylesDistPath + '/*.css',
                            '!./**/*modernizr*.js'
                        ],
                        {
                            allowEmpty: true,
                            base: './'
                        }
                    )
                    .pipe(plumber({
                        errorHandler: errorOpts
                    }))
                    .pipe(sourcemaps.init())
                    .pipe(sourcemaps.identityMap())
                    .pipe(modernizr('01-modernizr.js', modernizrpkg))
                    .pipe(dest(scriptsBuildPath + '/vendor'))
                    .pipe(uglify())
                    .pipe(dest(scriptsBuildPath + '/vendor'))
                    .pipe(onSuccess());
                }
                exports.compileModernizr = compileModernizr;
            // !SECTION: Compile Modernizer
            // --------------- SECTION: Create Vendor JS List --------------- //
                function createVendorJSList() {
                    var vendorJSarray = [];
                    Object.values(vendorJSFiles).forEach((item, index) => {
                        vendorJSarray[index] = item;
                    });
                    vendorJSarray = vendorJSarray.flat();
                    return vendorJSarray;
                }
                const vendorJSList = createVendorJSList();
            // !SECTION: Create Vendor JS List
            // --------------- SECTION: Create Vendor JS Array -------------- //
                function createVendorJSArray() {
                    var vendorJSarray = [];
                    Object.entries(vendorJSFiles).forEach((entry, i) => {
                        var index = i + 2;
                        var key = entry[0];
                        var value = entry[1];
                        key = (index < 10) ? '0' + index + '-' + key : index + '-' + key;
                        vendorJSarray[key] = value;
                    });
                    return vendorJSarray;
                }
                const vendorJSArray = createVendorJSArray();
            // !SECTION: Create Vendor JS Array
            // ------------------- SECTION: Copy Vendor JS ------------------ //
                function copyVendorJS() {
                    return src(vendorJSList, {
                        allowEmpty: true,
                        base: './'
                    })
                    .pipe(plumber({
                        errorHandler: errorOpts
                    }))
                    .pipe(newy(checkFile))
                    .pipe(sourcemaps.init())
                    .pipe(sourcemaps.identityMap())
                    .pipe(groupConcat(vendorJSArray))
                    .pipe(dest(scriptsBuildPath + '/vendor'))
                    .pipe(onSuccess());
                }
            // !SECTION: Copy Vendor JS
        // !SECTION: Vendor JS

        function compileMainScripts(done) {
            compileJS(mainJSFiles, scriptsDistPath, 'main', true);
            done();
        }

        function combineMainScripts(done) {
            combineJS([
                scriptsDistPath + '/' + gulpSlug + 'vendor.js',
                scriptsDistPath + '/' + gulpSlug + 'main.js'
                ],
                scriptsDistPath,
                fileBase = 'scripts',
                minify = isProd
            )
            done();
        }

        function adminScripts(done) {
            compileJS(adminJSFiles, adminPath, 'admin', true, isProd, false);
            done();
        }

        function pageScripts(done) {
            compileJS(pageJSFiles, pagesPath, 'page', true, isProd, false, true);
            done();
        }

        function vendorScripts(done) {
            compileJS(scriptsBuildPath + '/vendor/*', scriptsDistPath, 'vendor');
            done();
        }

        exports.mainScripts   = series(compileMainScripts, combineMainScripts);
        exports.adminScripts  = adminScripts;
        exports.pageScripts   = pageScripts;
        exports.vendorScripts = series(compileModernizr, copyVendorJS, vendorScripts);
        exports.buildScripts = parallel(series(compileMainScripts, combineMainScripts), adminScripts, pageScripts);
        exports.scripts       = parallel(
            series(compileMainScripts, combineMainScripts),
            adminScripts,
            pageScripts,
            vendorScripts
        );
    // !SECTION: Tasks

// !SECTION: JS

// ========================================================================== //
// ============================= SECTION: Images ============================ //
// ========================================================================== //

    // -------------------------- SECTION: Plugins -------------------------- //
        const imagemin = require('gulp-imagemin');
    // !SECTION: Plugins
    // ------------------------- SECTION: Variables ------------------------- //
        const
            imageFilter = filter(
                ['**/*.png', '**/*.gif', '**/*.jpg', '**/*.jpeg', '**/*.svg'],
                {
                    restore: true
                }
            );

    // !SECTION: Variables
    // --------------------------- SECTION: Tasks --------------------------- //
        function images() {
            return src(imageFiles, {
                base: './',
                nodir: true
            })
            .pipe(plumber({
                errorHandler: errorOpts
            }))
            .pipe(
                rename({
                    dirname: ''
                })
            )
            .pipe(newer(imagesDistPath))
            .pipe(imageFilter)
            .pipe(
                imagemin([
                    imagemin.gifsicle({
                        interlaced: true
                    }),
                    imagemin.jpegtran({
                        progressive: true
                    }),
                    imagemin.optipng({
                        optimizationLevel: 5
                    }),
                    imagemin.svgo({
                        plugins: [
                            {
                                removeViewBox: true
                            },
                            {
                                cleanupIDs: false
                            },
                            {
                                inlineStyles: true
                            }
                        ]
                    })
                ])
            )
            .pipe(imageFilter.restore)
            .pipe(dest(imagesDistPath))
            .pipe(onSuccess());
        }
        exports.images = images;
    // !SECTION: Tasks

// !SECTION: Images

// ========================================================================== //
// ============================= SECTION: Watch ============================= //
// ========================================================================== //

    // --------------------------- SECTION: Tasks --------------------------- //
        function watchFiles() {
            watch(mainSassFiles, mainStyles);
            watch(pageSassFiles, pageStyles);
            watch(adminSassFiles, adminStyles);
            watch(mainJSFiles, series(compileMainScripts, combineMainScripts));
            watch(adminJSFiles, adminScripts);
            watch(pageJSFiles, pageScripts);
            watch(imageFiles, images);
        }
        exports.watch = watchFiles;
    // !SECTION: Tasks

// !SECTION: Watch

// ========================================================================== //
// ============================= SECTION: Build ============================= //
// ========================================================================== //

exports.build = parallel(images, mainStyles, adminStyles, pageStyles, series(compileMainScripts, combineMainScripts), adminScripts, pageScripts);

// !SECTION: Build