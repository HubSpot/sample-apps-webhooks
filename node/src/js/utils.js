const url = require('url')

exports.logJson = (data) => {
    console.log('Response', JSON.stringify(data, null, 2))
}

exports.getHostUrl = (req) => {
    return url.format({
        protocol: 'https',
        hostname: req.get('host'),
    })
}