
'use strict';

var gulp = require('gulp');
var load = require('gulp-load-plugins')();
var browserSync = require('browser-sync');
var fs  = require('fs');
var buffer = require('vinyl-buffer');
var vinylPaths = require('vinyl-paths');
var del = require('del');
var es = require('event-stream');
var imageminMozjpeg = require('imagemin-mozjpeg');

// Настройки сборщика
var opt = {
    gulp: gulp,// Плагин gulp
    load: load,// Плагин автоподключения модулей gulp
    reload: browserSync.reload,
    browserSync: browserSync,
    buffer: buffer,
    vinylPaths: vinylPaths,
    del: del,
    fs: fs,// Плагин файловой системы
    es: es,// Плагин event-stream
    imageminMozjpeg: imageminMozjpeg,
    DIR: 'public',// Имя шаблона Битрикс
    sass: './src/scss/',// Путь к папке sass
    pkg: require('./package.json'),// Путь к файлу package.json
    banner: ['/*!\n' +
    //' * <%= pkg.name %> v<%= pkg.version %>\n' + // переменные берутся с package.json
    //' * 2016-<%= new Date().getFullYear() %> <%= pkg.author %> (<%= pkg.homepage %>)\n' +
    ' * <%= new Date().getFullYear() %> <%= pkg.homepage %>\n' +
    //' * Based on Bootstrap <%= pkg.bootstrap %>\n' +
    ' */ \n'],
    encoding: 'utf8',// Кодировка файлов
    name: {
        jade: 'index.jade',// Имя jade файлов
        scss: 'style.scss',// Имя scss файлов
        js: 'script.js'// Имя js файлов
    },

    // Проверяем, существует ли файл
    doesExist: function (path) {
        try {
            opt.fs.statSync(path);
            return true
        } catch(err) {
            return !(err && err.code === 'ENOENT');
        }
    },

    // Проверяем, Это папка или нет
    doesDir: function (path) {
        try {
            return opt.fs.statSync(path).isDirectory();
        } catch(err) {
            return !(err && err.code === 'ENOENT');
        }
    },

    // Проверяем, Это файл или нет
    doesFile: function (path) {
        try {
            return opt.fs.statSync(path).isFile();
        } catch(err) {
            return !(err && err.code === 'ENOENT');
        }
    },

    // Собираем пути картинок из модулей в массив
    getImgArrPath: function (path) {
        var arrPath = [];
        opt.modules.forEach(function (item, i, arr) {

            // Прописываем путь до каждого компонента папки sprite
            var newPath;
            if (item.lastIndexOf('/') > -1) {
                newPath = item.substring(0, item.lastIndexOf('/') + 1) + path + '/';
            }

            // Проверяем, существует ли папка images
            if (opt.doesExist(newPath) === true) {
                arrPath.push(newPath + '**/*');
            }
        });

        // В массив картинок добавляем безусловные картинки (всегда попадают в images)
        arrPath.push('./src/pic/base/' + path + '/**/*');
        return arrPath;
    },

    // Собираем пути картинок из модулей в массив
    getSvgArrPath: function (path) {
        var arrPath = [];
        opt.modules.forEach(function (item, i, arr) {

            // Прописываем путь до каждого компонента папки sprite
            var newPath;
            if (item.lastIndexOf('/') > -1) {
                newPath = item.substring(0, item.lastIndexOf('/') + 1) + path + '/';
            }

            // Проверяем, существует ли папка images{sprite, svg}
            if (opt.doesExist(newPath) === true) {
                opt.fs.readdirSync(newPath).forEach(function (item2, i, arr) {
                    var newItem = newPath + item2;
                    if (opt.doesFile(newItem)) {
                        // Определяем, встречается ли такое имя в массиве
                        var hasInArr = false;
                        arrPath.forEach(function (item3) {
                            if (item3.substring(item3.lastIndexOf('/') + 1, item3.length) === item2) {
                                hasInArr = true;
                            }
                        });
                        // Если нет - пушим
                        if (hasInArr === false) {
                            arrPath.push(newItem);
                        }
                    }
                });
            }
        });

        // В массив картинок добавляем безусловные картинки (всегда попадают в images)
        arrPath.push('./src/pic/base/' + path + '/**/*');
        return arrPath;
    },

    // Собираем в строку динамические строки из компонентов
    getDynamicString: function (file) {
        var string = '';
        opt.modules.forEach(function (item, i, arr) {
            var path = item + file;
            if (opt.doesExist(path) === true) {
                string += opt.fs.readFileSync(path, opt.encoding) + '\n';
            }
        });
        return string;
    },

    // Собираем в массив список файлов
    getFilesList: function (file) {
        var arrPath = [];
        opt.modules.forEach(function (item, i, arr) {
            var path = item + file;
            if (opt.doesExist(path) === true) {
                arrPath.push(path);
            }
        });
        return arrPath;
    },

    // A cache for Gulp tasks. It is used as a workaround for Gulp's dependency resolution
    // limitations. It won't be needed anymore starting with Gulp 4.
    task: {}
};

require('./src/tasks/getModules')(opt);// в объект opt.modules записывает массив используемых модулей
require('./src/tasks/html')(opt);
require('./src/tasks/sass')(opt);
require('./src/tasks/sass-libs')(opt);
require('./src/tasks/sprite')(opt);
require('./src/tasks/images')(opt);
require('./src/tasks/fonts')(opt);
require('./src/tasks/script')(opt);
require('./src/tasks/script-libs')(opt);
require('./src/tasks/apple')(opt);
require('./src/tasks/favicon')(opt);
require('./src/tasks/svg')(opt);
require('./src/tasks/cursor')(opt);


// Build the app from source code
opt.gulp.task('build', opt.load.sequence(
    'getModules',
    'images',
    'sprite',
    'svg',
    'svg2',
    /*'svg2:png',*/
    'cursor',
    'fonts',
    [
        'html',
        'sass',
        'sass-libs',
        'script',
        'script-libs',
        'apple',
        'favicon'
    ]
));

// Watcher
gulp.task('watch', ['build'], function () {
    browserSync.init({
        server: {
            baseDir: './' + opt.DIR
        },
        startPath: 'home.html'
    });


    //===  HTML
    opt.htmlFiles = opt.getFilesList(opt.name.jade);
    gulp.watch(['./src/pages/**/*', opt.htmlFiles], ['html-sync']);


    // === CSS
    opt.sassFiles = opt.getFilesList(opt.name.scss);
    gulp.watch(['./src/scss/**/*.scss', '!./src/scss/libs/**/*', opt.sassFiles], ['sass']);
    gulp.watch(['./src/scss/libs/*.scss'], ['sass-libs-sync']);


    // === JS
    opt.scriptFiles = opt.getFilesList(opt.name.js);
    gulp.watch(['./src/js/*.js', './src/js/bootstrap/**/*.js', opt.scriptFiles], ['script-sync']);
    gulp.watch('./src/js/libs/**/*.js', ['script-libs-sync']);

    // === Images
    gulp.watch(opt.arrImages, ['images-sync']);
    gulp.watch(opt.arrSprites, ['sprite-sync']);
    gulp.watch(opt.arrSvg, ['svg-sync']);
    gulp.watch(opt.arrSvg2, ['svg2-sync']);
});


// The default task
gulp.task('default', ['watch'], function () {
    console.log('Modules quantity: ' + opt.modules.length);
});
