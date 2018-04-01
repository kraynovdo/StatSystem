(function(){
    $('.match-groupSelector').change(function(){
        var id, location, newGroup, newLocation;
        id = $(this).val();
        location = document.location.toString();
        if (id) {
            newGroup = 'group=' + id;

            if (location.indexOf('group=') < 0) {
                newLocation = location + '&' + newGroup;
            }
            else {
                newLocation = location.replace(/group=[0-9]+/g, newGroup);
            }
        }
        else {
            newLocation = location.replace(/&group=[0-9]+/g, '');
        }
        document.location = newLocation;
    });
})();
