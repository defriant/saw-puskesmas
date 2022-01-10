$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$('.date-picker').datetimepicker({
    timepicker: false,
    format: 'Y-m-d'
})

$('.periodePicker').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    onClose: function (dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
})



