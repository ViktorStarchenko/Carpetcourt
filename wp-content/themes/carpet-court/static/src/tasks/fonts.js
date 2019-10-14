'use strict';

module.exports = function (opt) {
    
    // Очищаем папку с картинками
    opt.gulp.task('fonts:del', function () {
        return opt.del([
            './' + opt.DIR + '/fonts'
        ]);
    });
    
    // Копируем шрифты из fonts
    opt.gulp.task('fonts:copy', opt.task.copyFonts = function () {
        return opt.gulp.src('./src/fonts/**/*')
            .pipe(opt.load.plumber())
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/fonts'));
    });
    
    // Общая задача
    opt.gulp.task('fonts', ['fonts:copy']);
};