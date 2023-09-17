let strStr = function(haystack, needle) {

    let match = haystack.indexOf(needle)
    if (match >= 0) {
        return match
    } else {
        return -1;
    }
};