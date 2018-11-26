$(function () {
    $.fn.datepicker.dates['fr'] = {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
        monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jui", "Aoû", "Sep", "Oct", "Nov", "Déc"],
        format: "yyyy-mm-dd",
        titleFormat: "MM yyyy",
        weekStart: 0
    };
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        startDate: "new Date()",
        language: "fr",
        multidate: false,
        keyboardNavigation: false,
        daysOfWeekDisabled: "0,2",
        autoclose: true,
        todayHighlight: true,
        datesDisabled: ['01/05/2018', '01/11/2018', '25/12/2018'],
        toggleActive: true
    });
    $('.datepicker2').datepicker({
        format: "yyyy-mm-dd",
        language: "fr",
        multidate: false,
        keyboardNavigation: false,
        autoclose: true,
        endDate: "new Date()",
        toggleActive: true
    });
})