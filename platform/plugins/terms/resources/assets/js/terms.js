'use strict'

$(document).ready(function () {
    $(document).on('click', '.add-terms-schema-items', function (event) {
        event.preventDefault()

        $('.terms-schema-items').toggleClass('hidden')
    })
})
