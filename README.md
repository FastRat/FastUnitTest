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

##### condition for return

`(return >= true)` You can compare values with default type value such as *NULL*, *BOOLEAN*, *STRING*, *INTEGER*, *ARRAY*, *OBJECT*
