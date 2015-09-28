module.exports = {
    copy {
        main {
            files: [{
                src: ['src/.htaccess', 'src/robots.txt'],
                dest: 'dist/'
            }]
        }
    }
}
