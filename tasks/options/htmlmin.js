module.exports = {
    dist: {
        options: {
            removeComments: true,
            collapseWhitespace: true
        },
        files: {
            'production/index.html': 'index.html' // 'destination': 'source'
        }
    }
}
