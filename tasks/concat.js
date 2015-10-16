module.exports = {
    options: {
        stripBanners: true,
    },
    dist: {
        files: {
            'dist/assets/javascript/app.js' : ['src/assets/js/jquery.js', 'src/assets/js/jquery.lazyload.min.js', 'src/assets/js/holder.js', 'src/assets/js/app.js']
        }
    }
}
