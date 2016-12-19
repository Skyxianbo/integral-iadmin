'use strick';

var
    fs = require('fs'),
    url = require('url'),
    path = require('path'),
    http = require('http'),
    os = require('os'),
    ifaces = os.networkInterfaces();

// 从命令行参数获取root目录，默认是当前目录:
var root = path.resolve('.');
console.log('Static root dir: ' + root);

var server = http.createServer(function(request, response) {
    var pathname = url.parse(request.url).pathname;
    var filepath = path.join(root, pathname);
    if (!filepath.includes(".")) {
        filepath = path.join(filepath, "index.html");
        //判断index.html是否存在，否的话改filepath
        try {
            fs.statSync(filepath);
        } catch (err) {
            filepath = path.join(root, pathname, "default.html");
        }
    }

    // 获取文件状态:
    fs.stat(filepath, function(err, stats) {
        if (!err && stats.isFile()) {
            // 没有出错并且文件存在:
            console.log('200 ' + request.url);
            // 发送200响应:
            response.writeHead(200);
            // 将文件流导向response:
            fs.createReadStream(filepath).pipe(response);
        } else {
            // 出错了或者文件不存在:
            console.log('404 ' + request.url);
            // 发送404响应:
            response.writeHead(404);
            response.end('404 Not Found');
        }
    });
});

server.listen(8080);



// console.log('Server is running at http://' + ifaces.en0[1].address + ':8080/');
