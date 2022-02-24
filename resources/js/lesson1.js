console.log('123')

let n = 10

n = 99

const COLOR_RED = '#f00'

console.log(n)
console.log(COLOR_RED)

// Типы данных

let a = 1
let b = 0

let result = a / b
console.log(result)

console.log(typeof a)

// NaN = Not a Number
console.log(COLOR_RED - a)

console.log(a + b)

console.log(a + '0')

console.log(2 + 2 + '5')

console.log(2 ** 53 - 1)

let bg = 2374982734234n

console.log(bg, typeof bg)

let flag = false

console.log(flag, typeof flag)

let undefined_result
let new_result = null

console.log(undefined_result, typeof undefined_result)
console.log(new_result, typeof new_result)

let person = {
    name: 'Sahar',
    age: 31
}

console.log(person, typeof person)

console.log(typeof alert)

// alert, prompt, confirm

/* alert('Вот такое вот сообщение')
console.log('Вот это вот выводится после алерта')

let age = prompt('How old are you?', 'default value')
console.log(age)

let access = confirm('Вы уверены, что вам нужен доступ?')
console.log(access) */

// Приведение типов
let numb = 999
let numbString = String(numb)
console.log(numbString, typeof numbString)
numbString = Number(numbString)
console.log(numbString, typeof numbString)

let str = 'h sdh gshihg shi uhrisgrg '
console.log(Number(str))

console.log(new_result, Boolean(new_result))
console.log(undefined_result, Boolean(undefined_result))

console.log(new_result, Number(new_result))
console.log(undefined_result, Number(undefined_result))

console.log(Number('             12313      '))
console.log(Number('             1231f      '))