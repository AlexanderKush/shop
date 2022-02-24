/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/test.js ***!
  \******************************/
// const answer = prompt('сколько будет 2 + 2?')
answer = 99;

switch (answer) {
  case '4':
    {
      alert('правильно!');
      break;
    }

  case '3':
    {
      alert('больше!');
      break;
    }

  case '5':
    {
      alert('меньше');
      break;
    }
  // default: {
  //     alert('неправильно!')
  //     break
  // }
}

function sayHello() {
  str = 'Hello, World!';
  console.log('внутри функции', str);
}

function sum(a) {
  var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
  console.log(a + b);
}

function sum2(a, b) {
  if (b === undefined) {
    b = 0;
  }

  console.log(a + b);
}

function noReturn() {
  console.log('вызвали функции noReturn');
}

function fullName(firstName, lastName) {
  return firstName + ' ' + lastName;
}

var sayHelloWorld = function sayHelloWorld() {
  console.log('Hello, world!!!');
};

var str = 'Hello!';
sayHello();
console.log('после функции', str);
var a = 10;
var b = 15;
sum(1);
sum2(5);
var res = noReturn();
console.log('res = ', res);
var myName = fullName('Rail', 'Mingaliev');
console.log('name = ', myName);
console.log('sayHelloWorld', sayHelloWorld);
sayHelloWorld();

function callBackExample(access, accept, decline) {
  if (access) {
    accept();
  } else {
    decline();
  }
}

console.log('callBackExample', callBackExample); // const accept = function () {
//     alert('доступ предоставлен!')
// }
// const decline = function () {
//     alert('доступ запрещен')
// }

function accept() {
  alert('доступ предоставлен!');
}

function decline() {
  alert('доступ запрещен!');
}

callBackExample(false, accept, decline);

var arrowFunc = function arrowFunc(a, b, c) {
  return a + b + c;
};

console.log(arrowFunc(1, 2, 3));

arrowFunc = function arrowFunc(a, b, c) {
  return a + b + c;
};

console.log(arrowFunc(4, 5, 6));

var newArrowFunc = function newArrowFunc(a, b) {
  console.log('запустили стрелочную функцию newArrowFunc');
  return a + b;
};

console.log(newArrowFunc(4, 6));
var user = {
  name: 'Rail',
  age: 28
};
console.log(user);
console.log('user.name', user.name);
user.age = 29;
console.log(user);
delete user.age;
console.log(user);
user.age = 28;
console.log(user);

for (key in user) {
  console.log(user[key]);
}

console.log('name' in user);
console.log('car' in user);
/******/ })()
;