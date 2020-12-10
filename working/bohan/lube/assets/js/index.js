$(function () {
    // 手机端菜单按钮
    $('header .menu span').click(function () {
        if ($(this).hasClass('iconmenu')) {
            $(this).removeClass('iconmenu').addClass('iconclose')
            $('.mobile-nav').show()
            // 手机端二级菜单
            $('.first-nav > li.more').click(function () {
                $(this).toggleClass('active')
            })
        } else {
            $(this).removeClass('iconclose').addClass('iconmenu')
            $('.mobile-nav').hide()
            $('.first-nav > li.more').unbind('click')
        }
    })

    var toolsIsOpen = window.sessionStorage.getItem('toolsIsOpen')
    if (toolsIsOpen == 'false') {
        $('.tools-switch').css('opacity', 1)
        $('.tools').hide()
    }

    // 二期内容点击提示
    $(document.body).on('click', '.negative', function () {
        $('#developing').modal('show')
        setTimeout(function () {
            $('#developing').modal('hide')
        }, 1000)
    })

    var _width = $(window).width()
    if (_width < 992) {
        $("a[href^='#']").click(function (e) {
            e.preventDefault()
            var elm = $(this).attr('href')
            var _scrollTop = $(elm).offset().top - (_width / 100) * 14
            $(window).scrollTop(_scrollTop)
        })
    }
    // 选油助手
    var brandObj = {}
    $(document.body).on('show.bs.modal', '#choose-oil-assistant', function() {
        $.ajax({
            url: '/lube/api?action=getBrandList',
            success: function(res) {
                brandObj = res
                showBrand(res, $('#brand .list'))
            }
        })
    })

    function showBrand(data, el) {
        el.empty()
        var key = 0
        for (var i in data) {
            if (data[i].length > 0) {
                el.append('<strong>' + i + ' 字母开头</strong>')
                el.append('<ul></ul>')
                for (var j = 0; j < data[i].length; j++) {
                    el.find('ul').eq(key).append('<li>'+ i + ' ' + data[i][j] +'</li>')
                }
                key++
            }
        }
        if (key == 0) {
            el.append('<strong>未找到结果</strong>')
        }
    }

    // 选油助手显示隐藏列表
    $(document.body).on('click', '#brand .secection', function() {
        $(this).parent().toggleClass('on')
        $(this).parent().find('.search-input').focus()
    })

    $(document.body).on('click', '#brand', function(e) {
        e.stopPropagation()
    })
    
    // 选油助手点击空白处隐藏列表
    $(document.body).on('click', function() {
        $('#brand .select').removeClass('on')
        $('#brand .option input').val('')
    })

    // 选油助手input搜索
    $(document.body).on('input', '#brand input', function() {
        var val = $(this).val().toLocaleUpperCase()
        if (!val) {
            showBrand(brandObj, $('#brand .list'))
            return
        }
        var result = {}
        for (var i in brandObj) {
            result[i] = []
            for (var j = 0; j < brandObj[i].length; j++) {
                if (brandObj[i][j].indexOf(val) != -1) {
                    result[i].push(brandObj[i][j])
                }
            }
        }
        showBrand(result, $('#brand .list'))
    })
    
    var brand
    var factory
    var modal
    $(document.body).on('click', '#brand li', function() {
        brand = $(this).text().slice(2)
        var input = $(this).parents('.form-group').find('input[name=brand]')
        $(this).parents('.select').removeClass('on').find('span').text(brand)
        input.val(brand)
        input[0].setCustomValidity('')
        $(this).parents('.list').empty().siblings().val('')
        showBrand(brandObj, $('#brand .list'))
        chooseOption('#factory', {brand: brand})
		$('#factory select').empty().append('<option value="">请选择车厂</option>')
		$('#model select').empty().append('<option value="">请选择车型</option>')
		$('#year select').empty().append('<option value="">请选择生产年份</option>')
    })

    // 选择车厂、车型、生产年份
    function chooseOption(el, data) {
        var text = $(el).find('select option').eq(0).text()
        $.ajax({
            url: '/lube/api?action=' + $(el).data('action'),
            data: data,
            success: function(json) {
                $(el).find('select').empty()
                $(el).find('select').append('<option value="">'+ text +'</option>')
                for (var i = 0; i < json.length; i++) {
                    $(el).find('select').append('<option value="'+ json[i] +'">'+ json[i] +'</option>')
                }
            }
        })
    }
	$(document.body).on('change', '#factory', function() {
		factory = $(this).find('option:selected').val()
		chooseOption('#model', {brand: $('input[name=brand]').val(), factory: factory})
		$('#model select').empty().append('<option value="">请选择车型</option>')
		$('#year select').empty().append('<option value="">请选择生产年份</option>')
	})

	$(document.body).on('change', '#model', function() {
		model = $(this).find('option:selected').val()
		chooseOption('#year', {brand: $('input[name=brand]').val(), factory: $('select[name=factory]').val(), model: model})
		$('#year select').empty().append('<option value="">请选择生产年份</option>')
   })
})

// 页面滚动显示返回顶部按钮
$(window).scroll(function () {
    if ($(window).scrollTop() >= 600) {
        $('.toTop').show()
    } else {
        $('.toTop').hide()
    }
})

function toTop() {
    $('html,body').animate({ scrollTop: '0px' }, 800)
}

function shutUpTools() {
    $('.tools-switch').animate({ opacity: 1 }, 500)
    $('.tools').slideUp()
    window.sessionStorage.setItem('toolsIsOpen', false)
}

function showTools() {
    $('.tools-switch').animate({ opacity: 0 }, 500)
    $('.tools').slideDown()
    window.sessionStorage.setItem('toolsIsOpen', true)
}

var _hmt = _hmt || []
;(function () {
    var hm = document.createElement('script')
    hm.src = 'https://hm.baidu.com/hm.js?b35d1ffc9fe7c11bc16def41bf2da3d8'
    var s = document.getElementsByTagName('script')[0]
    s.parentNode.insertBefore(hm, s)
})()
