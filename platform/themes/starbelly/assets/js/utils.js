const handleError = data => {
    if (typeof (data.errors) !== 'undefined' && data.errors.length) {
        handleValidationError(data.errors)
    } else if (typeof (data.responseJSON) !== 'undefined') {
        if (typeof (data.responseJSON.errors) !== 'undefined') {
            if (data.status === 422) {
                handleValidationError(data.responseJSON.errors)
            }
        } else if (typeof (data.responseJSON.message) !== 'undefined') {
            showError(data.responseJSON.message)
        } else {
            $.each(data.responseJSON, (index, el) => {
                $.each(el, (key, item) => {
                    showError(item)
                })
            })
        }
    } else {
        showError(data.statusText)
    }
}

const handleValidationError = errors => {
    let message = ''
    $.each(errors, (index, item) => {
        if (message !== '') {
            message += '<br />'
        }
        message += item
    })
    showError(message)
}

const showError = message => {
    showAlert('alert-danger', message)
}

const showSuccess = message => {
    showAlert('alert-success', message)
}

const showAlert = (messageType, message) => {
    if (messageType && message !== '') {
        const toastLive = $('#live-toast')
        const toast = new bootstrap.Toast(toastLive[0])
        toastLive.removeClass(function(index, className) {
            return (className.match(/(^|\s)alert-\S+/g) || []).join(' ')
        })
        toastLive.find('.toast-body').html(message)
        toastLive.addClass(messageType)
        toast.show()
    }
}

const setCookie = (name, value, expiresDate) => {
    const date = new Date()
    let siteUrl = window.siteUrl

    if (!siteUrl.includes(window.location.protocol)) {
        siteUrl = window.location.protocol + siteUrl
    }

    let url = new URL(siteUrl)
    date.setTime(date.getTime() + (expiresDate * 24 * 60 * 60 * 1000))
    const expires = 'expires=' + date.toUTCString()
    document.cookie = name + '=' + value + '; ' + expires + '; path=/' + '; domain=' + url.hostname
}

const getCookie = (name) => {
    const cookieName = name + '='
    const cookies = document.cookie.split(';')

    for (let i = 0; i < cookies.length; i++) {
        let c = cookies[i]
        while (c.charAt(0) === ' ') {
            c = c.substring(1)
        }
        if (c.indexOf(cookieName) === 0) {
            return c.substring(cookieName.length, c.length)
        }
    }
    return ''
}

const clearCookies = (name) => {
    let siteUrl = window.siteUrl

    if (!siteUrl.includes(window.location.protocol)) {
        siteUrl = window.location.protocol + siteUrl
    }

    let url = new URL(siteUrl)
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/' + '; domain=' + url.hostname
}

export { handleError, handleValidationError, showError, showAlert, showSuccess, setCookie, getCookie, clearCookies }
