fetch('http://wushu.com/wp-json/members/v1/all').then((res)=>{
   res.json().then((val)=>{
    console.log(val)
   })
})

console.log("HELL BRO")