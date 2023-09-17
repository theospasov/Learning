var lengthOfLastWord = function(s) {
    let together =  s.trim().split(' ')
    return together[together.length-1].length
 };