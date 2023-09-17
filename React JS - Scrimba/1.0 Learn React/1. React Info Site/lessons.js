// // 14
// import React from 'react'
// import reactDOM from 'react-dom'

// const page = (
//     <div>
//         <img src="./react-logo.png" width="40px"/>
//         <h1>Fun facts about React</h1>
//         <ul>
//             <li>1</li>
//             <li>2</li>
//             <li>3</li>
//             <li>4</li>
//         </ul>
//     </div>
// )

// reactDOM.render(page, document.querySelector("#root"))


// // 16
// import React from 'react'
// import ReactDOM from 'react-dom'

// function Page(){
//     return (
//         <ol>
//                 <li>It's cool</li>
//                 <li>Lot's of jobs</li>
//                 <li>It's fast</li>
//         </ol>
//     )
// }

// ReactDOM.render(<Page/>, document.querySelector('#root'))


// // 17
// Part 2: 
// - Add a `header` element with a nested `nav` element. Inside the `nav`,
//   include a `img` element with the image of the React logo inside
//   (src="./react-logo.png") and make sure to set the width to something
//   more manageable so it doesn't take up the whole screen
// - Add an `h1` with some text describing the page. (E.g. "Reasons
//   I'm excited to learn React"). Place it above the ordered list.
// - Add a `footer` after the list that says: 
//     "© 20xx <last name here> development. All rights reserved."
//  */

// import React from "react"
// import ReactDOM from "react-dom"

// function Page() {
//     return (
//         <div>
//         <header>
//             <nav>
//                 <img src="./react-logo.png" width="40px"/>
//             </nav>
//         </header>
//         <h1>Why learn React</h1>
//         <ol>
//             <li>It's a popular library, so I'll be 
//             able to fit in with the cool kids!</li>
//             <li>I'm more likely to get a job as a developer
//             if I know React</li>
//         </ol>
//         <footer> © 2023 Teo development. All rights reserved.</footer>
//         </div>
//     )
// }

// ReactDOM.render(<Page />, document.getElementById("root"))

// // 19
// import React from "react"
// import ReactDOM from "react-dom"

/**
Mini Challenge:
Move the `header` element from Page into 
its own component called "Header"
*/

/**
Challenge: 

- Move the `footer` into its own component called "Footer" 
  and render that component inside the Page component.
- Move the `h1` and `ol` together into another component
  called "MainContent" and render inside Page as well.
*/


// function Header() {
//     return (
//         <header>
//             <nav>
//                 <img src="./react-logo.png" width="40px" />
//             </nav>
//         </header>
//     )
// }

// function MainContent() {
//     return (
//         <div>
//             <h1>Reasons I'm excited to learn React</h1>
//             <ol>
//                 <li>It's a popular library, so I'll be
//                     able to fit in with the cool kids!</li>
//                 <li>I'm more likely to get a job as a developer
//                     if I know React</li>
//             </ol>
//         </div>
//     )
// }

// function Footer() {
//     return (
//         <footer>
//             <small>© 2021 Ziroll development. All rights reserved.</small>
//         </footer>
//     )
// }

// function Page() {
//     return (
//         <div>
//             <Header />
//             <MainContent />
//             <Footer />
//         </div>
//     )
// }

// ReactDOM.render(<Page />, document.getElementById("root"))


// // 20
import React from "react"
import ReactDOM from "react-dom"

/**
Challenge: 

- Add an `ul` inside the Header's `nav` and create
  the following `li`s: "Pricing", "About", & "Contact"
*/

function Header() {
    return (
        <header>
            <nav>
                <img src="./react-logo.png" width="40px" />
                <ul>
                    <li>Pricing</li>
                    <li>About</li>
                    <li>Contact</li>
                </ul>
            </nav>
        </header>
    )
}

function Footer() {
    return (
        <footer>
            <small>© 2021 Ziroll development. All rights reserved.</small>
        </footer>
    )
}

function MainContent() {
    return (
        <div>
            <h1>Reasons I'm excited to learn React</h1>
            <ol>
                <li>It's a popular library, so I'll be 
                able to fit in with the cool kids!</li>
                <li>I'm more likely to get a job as a developer
                if I know React</li>
            </ol>
        </div>
    )
}

function Page() {
    return (
        <div>
            <Header />
            <MainContent />
            <Footer />
        </div>
    )
}

ReactDOM.render(<Page />, document.getElementById("root"))