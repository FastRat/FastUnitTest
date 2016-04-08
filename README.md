# FastUnitTest
---

##Document class for create test
You must usage special tag in comment block before class, method and variable

##Usaged:

### Register param
`@test param $a rand(1,100)`
`@test param $b uniqid()`
`@test param $c "stable word"`


#### Register return
`@test return success {condition}`
`@test return error {condition}`
`@test return fail {condition}`

#### Result return
`@test result success {condition}`
`@test result error {condition}`
`@test result fail {condition}`


##### condition for return
`(return >= true)` You can compare values with default type value such as *NULL*, *BOOLEAN*, *STRING*, *INTEGER*, *ARRAY*, *OBJECT*
`return` This is value, than method is return
`object` This is objeect, that is testing