## 15
1. Why do we need to `import React from "react"` in our files?
We need to import the React library to use JSX

2. If I were to console.log(page) in index.js, what would show up?
An React element in the from of an Object

3. What's wrong with this code:
```
const page = (
    <h1>Hello</h1>
    <p>This is my website!</p>
)
```
There must be only 1 parent element

4. What does it mean for something to be "declarative" instead of "imperative"?
We tell the library what to do, instead of how to do it. 

5. What does it mean for something to be "composable"?
It's made from small blocks (components), like Lego

## 18

1. What is a React component?
A function that return JSX code

2. What's wrong with this code?
```
function myComponent() {
    return (
        <small>I'm tiny text!</small>
    )
}
```
it uses camelCase, instead of PascalCase

3. What's wrong with this code?
```
function Header() {
    return (
        <header>
            <nav>
                <img src="./react-logo.png" width="40px" />
            </nav>
        </header>
    )
}

ReactDOM.render(Header(), document.getElementById("root"))
```
In the render, the Header element should be written as <Header/> 