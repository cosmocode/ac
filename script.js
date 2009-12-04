function sack_form(form, func) {
    var ajax = new sack(DOKU_BASE + 'lib/exe/ajax.php');
    function serializeByTag(tag) {
        var inps = form.getElementsByTagName(tag);
        for (var inp in inps) {
            if (inps[inp].name) {
                ajax.setVar(inps[inp].name, inps[inp].value);
            }
        }
    }
    serializeByTag('input');
    serializeByTag('textarea');
    ajax.elementObj = form.parentNode;
    ajax.afterCompletion = func;
    ajax.runAJAX();
    return false;
}

addInitEvent(function() {
    function sack_em() {
        var forms = getElementsByClass('ajax_loader', document, 'form');
        if (forms.length > 0) sack_form(forms[0], sack_em);
    };
    sack_em();
});
