import cookie from './cookie'
import { BASE_URL, APP_INFO } from '../config'
let http = {
  _getRequestHeader: function () {
    let cookies = cookie.getCookies()
    // let cookieArray = []
    // Object.keys(cookies).forEach(key => {
    //   cookieArray.push(encodeURIComponent(key) + '=' + encodeURIComponent(cookies[key]))
    // })
    const header = {}
    if(cookies.token){
      header.Authorization = ` Bearer ${cookies.token}`
    }
    return header
  },
  _getRequestData: function () {
    return APP_INFO
  },
  request: function (options) {
    if (options.loading) {
      uni.showLoading({ title: typeof options.loading === 'string' ? options.loading : '正在加载...' })
    }
    if (options.barLoading) {
      uni.showNavigationBarLoading()
    }
    let header = {
      ...this._getRequestHeader(),
      ...options.header
    }
    // let data = {
    //   ...this._getRequestData(),
    //   ...options.data
    // }

    if (options.url.indexOf('/') === 0) {
      options.url = BASE_URL + options.url
    }
    return uni.request({
      method: 'POST',
      ...options,
      header,
      complete () {
        typeof options.complete === 'function' && options.complete()
        options.loading && uni.hideLoading()
        options.barLoading && uni.hideNavigationBarLoading()
      }
    })
  }

}

export default function (opt) {
  return new Promise((resolve, reject) => {
    http.request({
      ...opt,
      success ({data, statusCode}) {
        const status = Number(statusCode)
        if (status === 200) {
          resolve(data)
        } else if (status === 401 && !uni.isRedirect) { // 重新登录
          uni.isRedirect = true
          cookie.clearCookie()
          uni.navigateTo({ url: '/pages/login/main' })
        } else {
          reject(data || data.msg || '请求失败')
        }
      },
      fail (err) {
        reject(err)
      }
    })
  })
}
