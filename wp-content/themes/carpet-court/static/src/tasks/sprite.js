'use strict';

module.exports = function (opt) {

    // Собираем пути картинок из модулей в массив
    opt.gulp.task('sprite:getImgArr', function () {
        // массив путей картинок из компонентов sprites
        opt.arrSprites = opt.getImgArrPath('sprite');
    });

    // Собираем картинки в спрайт
    opt.gulp.task('sprite:create', opt.task.spriteCreate = function () {
        var spriteData = opt.gulp.src(opt.arrSprites)
            .pipe(opt.load.spritesmith({
                /*retinaSrcFilter: ['./!*@2x.png'],
                retinaImgName: 'sprite@2x.png',*/
                imgName: 'sprite.png',
                cssFormat: 'scss',
                cssName: '_sprite.scss',
                algorithm: 'binary-tree',
                cssTemplate: './src/scss/base/__spritetemplate.scss',
                padding: 2,
                cssVarMap: function (sprite) {
                    sprite.name = 'sp-' + sprite.name
                }
            }));

        var imgStream = spriteData.img
            .pipe(opt.buffer())
            //.pipe(opt.load.imagemin())
            .pipe(opt.gulp.dest(opt.DIR + '/images/'));

        spriteData.css.pipe(opt.gulp.dest('./src/scss/base/')); // путь, куда сохраняем стили

        return imgStream;
    });

    // Общая задача по сборке спрайта
    opt.gulp.task('sprite', ['sprite:getImgArr'], opt.task.spriteCreate);
    opt.gulp.task('sprite-sync', ['sprite']/*, opt.reload*/);// Не релоадим, изменится SASS файл, на нем сработает релоад
};