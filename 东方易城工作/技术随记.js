/**
 * socket.io.js
 */


/**
 * token
 */

/**
 * base64
 */

1. 编码转换方式。编码->解码
2. 64个字符集作为一个基本字符集
3. 编码后的文本，会比原文本大出1/3左右

when use: 图片等数据->字符串。 不可读，减少http请求

/**
 * weui
 */
1. tencent为微信设计的ui库
2. 


/**
 * DOM对象方法
 */
x.querySelector(".example")：只返回第一个元素, querySelectorAll()




/**
 * async/await,  promsie
 */
async函数: 返回一个 Promise 对象，可以使用 then 方法添加回调函数
await：     1. 用于等待一个 Promise 对象， 仅在 async function 中有效
            2. Promise 对象：await 会暂停执行，等待 Promise 对象 resolve，然后恢复 async 函数的执行并返回解析值。
            3. 非 Promise 对象：直接返回对应的值。


promise:    1. 3状态：pending, fulfilled, rejected 
            2. 只要处于 fulfilled 和 rejected ，状态就不会再变了即 resolved（已定型）。
            3. 如果不设置回调函数，Promise 内部抛出的错误，不会反应到外部
            4. .then() 接收2函数作参，成功/失败，2函数只会有一个被调用。
            5. 通过 .then 形式添加的回调函数，不论什么时候，都会被调用。可添加多个then即回调，独立运行
        
     