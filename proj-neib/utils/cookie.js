let cookie = {
  isLogin: function () {
    return !!(this.getCookie('token') && this.getCookie('name'))
  },
  getCookies: function () {
    return uni.getStorageSync('cookie') || {}
  },

  setCookies: function (cookies) {
    uni.setStorageSync('cookie', cookies)
  },

  getCookie: function (key) {
    let cookies = this.getCookies()
    return cookies[key]
  },

  setCookie: function (key, value) {
    let cookies = this.getCookies()
    cookies[key] = value
    this.setCookies(cookies)
  },

  removeCookie: function (key) {
    let cookies = this.getCookies()
    delete cookies[key]
    this.setCookies(cookies)
  },

  clearCookie: function () {
    this.setCookies({})
  }
}

export default cookie
