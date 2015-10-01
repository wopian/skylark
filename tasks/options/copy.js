module.exports = {
    dist: {
        files: [{
            //Root of source -> Root of domain
            expand: true,
            cwd: 'src/',
            src: ['.htaccess', 'robots.txt'],
            dest: 'dist/'
        },
        {
            expand: true, 
            cwd: 'src/assets/php/', 
            src: ['**'], 
            dest: 'dist/assets/php/'
        }]
    }
}
