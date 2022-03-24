import WordCase from '../Components/WordCase';

const { render } = wp.element;

class MangoCube_Word_Case_sensitive extends HTMLElement {
  connectedCallback() {

      this.innerHTML = `     
    <span></span>
    `;
    const mountPoint = this.querySelector("span");
    
    // this.attachShadow({ mode: 'open' }).appendChild(mountPoint);

     render(<WordCase />, mountPoint);

  }
}

customElements.define('mangocube-text-case-sensitive', MangoCube_Word_Case_sensitive);
