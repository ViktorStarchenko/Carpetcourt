'use strict';

module.exports = function (opt) {

    // Собираем пути картинок из модулей в массив
    opt.gulp.task('svg:getArr', function () {
        // массив путей картинок из компонентов svg
        opt.arrSvg = opt.getSvgArrPath('svg');
    });

    // Генерим SVG иконки в шрифт, создаем автоматически SASS классы для этих картинок
    opt.gulp.task('svg:iconfont', ['svg'], opt.task.iconfont = function() {
        var fontName = 'sprite';
        return opt.gulp.src(opt.arrSvg,
            {base: 'src'})
            .pipe(opt.load.svgmin({
                js2svg: {
                    pretty: true
                }
            }))
            // remove all fill and style declarations in out shapes
            .pipe(opt.load.cheerio({
                run: function ($) {
                    $('[fill]').removeAttr('fill');
                    $('[style]').removeAttr('style');
                },
                parserOptions: { xmlMode: true }
            }))
            // cheerio plugin create unnecessary string '>', so replace it.
            .pipe(opt.load.replace('&gt;', '>'))
            .pipe(opt.load.iconfontCss({
                fontName: fontName,
                path: opt.sass + 'base/__iconstemplate.scss',
                targetPath: '../../src/scss/base/_icons.scss', // путь от app.min.css
                fontPath: '../fonts/', // путь от app.min.css
                cssClass: 'ic'
            }))
            .pipe(opt.load.iconfont({
                fontName: fontName,
                normalize: true, //Normalize icons by scaling them to the height of the highest icon.
                formats: ['woff', 'woff2'],
                fontHeight: 1001
            }))
            .pipe(opt.gulp.dest(opt.DIR + '/fonts/'));
    });

    // Общая задача по сборке SVG спрайта
    opt.gulp.task('svg', ['svg:getArr'], opt.task.iconfont);
    opt.gulp.task('svg-sync', ['svg'], opt.reload);

    //**********************************************//

    // Собираем пути картинок из модулей в массив
    opt.gulp.task('svg2:getArr', function () {
        // массив путей картинок из компонентов svg
        opt.arrSvg2 = opt.getSvgArrPath('svg2');
    });

    // Генерим SVG иконки в шрифт, создаем автоматически SASS классы для этих картинок
    opt.gulp.task('svg2:iconfont', ['svg2'], opt.task.iconfont2 = function() {
        return opt.gulp.src(opt.arrSvg2)
            .pipe(opt.load.svgSprites({
                selector: 'ic2-%f',
                common: 'ic2',
                templates: {
                    // scss: true,
                    scss: opt.fs.readFileSync('src/scss/base/__svgtemplate.scss', opt.encoding)
                },
                svg: {
                    sprite: 'images/sprite_svg.svg'// Куда положить спрайт, относительно dest в последней строке
                },
                cssFile: '../src/scss/base/_svg.scss',// Относительно dest в последней строке
                preview: false,
                //baseSize: 10,// базовый размер шрифта
                padding: 2
            }))
            .pipe(opt.gulp.dest(opt.DIR + '/'));
    });

    // Генерим PNG fallback for SVG
    opt.gulp.task('svg2:png',  function() {
        return opt.gulp.src(opt.DIR + '/images/sprite_svg.svg')
            // .pipe(opt.load.filter('**/*.svg'))//ToDo (2) в пути с точкой не рабоатет
            .pipe(opt.load.svg2png()) // Create a PNG
            .pipe(opt.gulp.dest(opt.DIR + '/images'));
    });

    // Общая задача по сборке SVG спрайта
    opt.gulp.task('svg2', ['svg2:getArr'], opt.task.iconfont2);
    opt.gulp.task('svg2-sync', ['svg2'], opt.reload);
};