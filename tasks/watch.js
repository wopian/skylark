module.exports = {
    options: {
        livereload: true,
    },
    scripts: {
        files: ['js/*.js'],
        tasks: ['jshint', 'concat', 'uglify'],
        options: {
            spawn: false,
        }
    },
    css: {
        files: ['css/*.scss'],
        tasks: ['sass', 'autoprefixer', 'cssmin'],
        options: {
            spawn: false,
        }
    },
    images: {
        files: ['src/assets/images/**/*.{png,jpg,gif}', 'src/assets/images/*.{png,jpg,gif}'],
        tasks: ['imagemin'],
        options: {
            spawn: false,
        }
    },
    html:{
        files: ['./**/*.html'],
        tasks: [],
        options: {
            spawn: false
        }
    }
}
