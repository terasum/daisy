var gulp = require("gulp");
var babel = require("gulp-babel");
var uglify = require("gulp-uglifyjs");
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var nano = require('gulp-cssnano');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var less = require('gulp-less');
var browserify = require('gulp-browserify');

gulp.task('less',function() {
    return gulp.src(['less/style.less'])
        .pipe(less().on('error', function (e){
            console.error(e.message);
            this.emit('end');
        }))
        .pipe(postcss([autoprefixer]))
        .pipe(nano())
        .pipe(gulp.dest('build/css'))
});

gulp.task("highlight",function(){
    return gulp.src(['js/base.js','js/webfont.js','js/html5.js'])
            .pipe(rename('highlight.pack.js'))
            .pipe(gulp.dest('build/js'));
})

gulp.task("uglify", function() {
    
    return gulp.src(['js/base.js'])
        .pipe(concat('all.js'))
        .pipe(browserify({
            insertGlobals : true,
            debug : !gulp.env.production
          }))
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(uglify('all.js',{
            mangle: true,
            }))
        .pipe(rename('application.js'))
        //.pipe(rev())
        .pipe(gulp.dest("build/js"));
});

gulp.task('js',['uglify','highlight']);

gulp.task('watch',function() {
    gulp.watch(['less/*.less'],['less']);
    gulp.watch(['js/base.js'], ['js']);
});

gulp.task('default', ['less','js','watch']);
