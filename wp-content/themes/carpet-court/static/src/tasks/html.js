'use strict';

module.exports = function (opt) {
    
    opt.gulp.task('html', function () {
        return opt.gulp.src('./src/pages/proj/**/*.jade')
            .pipe(opt.load.plumber())
            .pipe(opt.load.changed('./' + opt.DIR))
            .pipe(opt.load.jade({
                //pretty: true// не сжимать html
                pretty: '\t'// форматировать табами
            }))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./'  + opt.DIR));
    });
    
    opt.gulp.task('html-sync', ['html'], opt.reload);
    
};