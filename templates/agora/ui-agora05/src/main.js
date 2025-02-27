import './style.css'
import { createElement, Plus, Loader } from 'lucide'
import { setupCounter } from './counter.js'
import { setupPing } from './ping.js'
import ENV from './env.js'

const uriCookie = ENV.baseUrl + 'sanctum/csrf-cookie'
const uriApi = ENV.baseUrl + 'api/ping'


const plusIconElement = createElement(Plus)
const loaderIconElement = createElement(Loader, {
  class: ['w-20 h-20 text-orange-400 animate-[spin_1s_ease-in-out_infinite]'],
  'stroke-width': 1
})

document.querySelector('#app').innerHTML = `
  <div>
    <h3 class="text-indigo-400">Agora</h3>
    <div class="card">
      <button id="increment" class="text-indigo-400" type="button"></button>
      <output id="counter" for="increment" class="block mt-4 text-2xl text-indigo-400"></output>
    </div>
    <div class="card">
      <h5 id="loader" class="flex items-center"></h5>
      <output id="retriever" class="block mt-4 text-2xl text-slate-400"></output>
    </div>
  </div>
`

//  class=""

document.querySelector('#increment').appendChild(plusIconElement)
document.querySelector('#loader').appendChild(loaderIconElement)

setupCounter(
  document.querySelector('#increment'),
  document.querySelector('#counter')
)

setupPing(
  uriCookie,
  uriApi,
  document.querySelector('#loader'),
  document.querySelector('#retriever')
)
