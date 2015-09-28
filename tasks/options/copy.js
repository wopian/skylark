module.exports = {
    dist: {
        files: [{
            //Root of source -> Root of domain
            expand: true,
            cwd: 'src/',
            src: ['.htaccess', 'robots.txt'],
            dest: 'dist/'
        }]
    }
}
