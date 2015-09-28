module.exports = {
    main {
        files: [{
            expand: true,
            src: ['src/.htaccess', 'src/robots.txt'],
            dest: 'dist/'
        }]
    }
}
