module.exports = {
    dist: {
        options: {
            style: 'expanded',
            check: true,
        },
        files: {
            'app/assets/css/app.css': 'dev/assets/scss/base.scss'
        }
    }
}
