'use strict';

module.exports = function (opt) {

    // Собираем в строку динамические скрипты из компонентов
    opt.gulp.task('script:getArr', function () {
        opt.script = opt.getDynamicString(opt.name.js);
    });

    // ToDo (2) при синтаксической ошибке все равно исполняется
    opt.gulp.task('script:compile', opt.task.scriptCompile = function () {
        return opt.gulp.src('./src/js/app.js')
            .pipe(opt.load.plumber())
            .pipe(opt.load.insert.append(opt.script))// Добавляем в конец файла строки
            .pipe(opt.load.changed('./' + opt.DIR + '/js/*.js'))
            .pipe(opt.load.jshint())
            .pipe(opt.load.jshint.reporter('jshint-stylish'))
            .pipe(opt.load.jshint.reporter('fail'))
            .pipe(opt.load.preprocess())
            .pipe(opt.load.uglify())
            //.pipe(opt.load.header(opt.banner, { pkg : opt.pkg } ))
            .pipe(opt.load.rename({suffix: '.min'}))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/js'));
    });
    
    opt.gulp.task('script:bootstrap', opt.task.bootstrapCompile = function () {
        return opt.gulp.src('./src/js/bootstrap.js')
            .pipe(opt.load.plumber())
            .pipe(opt.load.changed('./' + opt.DIR + '/js/*.js'))
            .pipe(opt.load.jshint())
            .pipe(opt.load.jshint.reporter('jshint-stylish'))
            .pipe(opt.load.jshint.reporter('fail'))
            .pipe(opt.load.preprocess())
            .pipe(opt.load.uglify())
            //.pipe(opt.load.header(opt.banner, { pkg : opt.pkg } ))
            .pipe(opt.load.rename({suffix: '.min'}))
            .on('error', opt.load.util.log)
            .pipe(opt.gulp.dest('./' + opt.DIR + '/js'));
    });


    // Общая задача по сборке app.min.js
    opt.gulp.task('bootstrap', ['script:getArr'], opt.task.bootstrapCompile);
    opt.gulp.task('script', ['bootstrap'], opt.task.scriptCompile);
    opt.gulp.task('script-sync', ['script'], opt.reload);
};