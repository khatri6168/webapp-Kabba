import { showAlert } from './utils'

window.showAlert = showAlert

$(document).ready(function() {
    if (window.noticeMessages) {
        let messages = ''
        window.noticeMessages.forEach(message => {
            messages += `<li class='${message.type === 'error' ? 'text-danger' : 'text-success'}'>${message.message}</li>`
        })
        showAlert('alert-info', '<ul class="toast-list">' + messages + '</ul>')
    }
})
