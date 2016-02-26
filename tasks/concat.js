module.exports = {
    options: {
        stripBanners: true,
    },
    dist: {
        files: {
            'dist/assets/js/app.js' : ['src/assets/js/vendor/materialize.min.js']
        }
    }
}
