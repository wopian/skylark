module.exports = {
    dist: {
    files: [{
        expand: true,
        cwd: 'src/'
        src: ['.htaccess', 'robots.txt', 'hello_world.txt'],
        dest: 'dist/'
    }]
    }
}
