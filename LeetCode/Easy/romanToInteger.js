var romanToInt = function(s) {
    let nums = {
        I: 1,
        V: 5,
        X: 10,
        L: 50,
        C: 100,
        D: 500,
        M: 1000,
      }
    
    let count = 0
    
    for (let i=0;i<s.length;i++) {
     let currentValue = nums[s[i]];
      if (i + 1 < s.length && nums[s[i+1]] > currentValue) {
        count -= currentValue;
    } else {
        count += currentValue;
    }
    }
    return count
    
    };