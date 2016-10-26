//倒计时格式化
exports.formatDate = (t) => {
    let res = '',
  		  seconds = Math.floor( (t/1000) % 60 ),
  		  minutes = Math.floor( (t/1000/60) % 60 ),
  		  hours = Math.floor( (t/(1000*60*60)) % 24 ),
  		  days = Math.floor( t/(1000*60*60*24) );
  		  res = days + '天 ' + hours+'时 '+ minutes +'分 ' + seconds+'秒 '
		  return  res;
}