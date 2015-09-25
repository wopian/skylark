module.exports = {
    options: {
        stripBanners: true,
    },
    dist: {
        files: {
            'app/assets/javascript/app.js' : ['dev/assets/js/jquery.js', 'dev/assets/js/jquery.lazyload.min.js', 'dev/assets/js/holder.js', 'dev/assets/js/app.js', 'dev/assets/js/headroom.min.js', 'dev/assets/js/headroom.options.js']
        }
    }
}
