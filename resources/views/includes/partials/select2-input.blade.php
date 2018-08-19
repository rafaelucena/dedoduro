function formatItem (item) {
    if (!item.id) {
        return item.text;
    }
    return $('<span>' + item.text + '</span>');
}

$('.select2-input').select2({
    theme: "bootstrap",
    tags: {{ $formHelper->select2Helper->allowDynamicOption }},
    placeholder: '{{ $formHelper->select2Helper->placeholder }}',
    minimumInputLength: 2,
    maximumSelectionLength: 3,
    delay : 100,
    tokenSeparators: [',','.'],
    ajax: {
        url: '{{ $formHelper->select2Helper->ajaxUrl }}',
        dataType: 'json',
        cache: true,
        data: function(params) {
            return {
                term: params.term || '',
                page: params.page || 1
            };
        },
    },
    templateResult: formatItem,
    templateSelection: formatItem
});
$('.select2-input').trigger('change');