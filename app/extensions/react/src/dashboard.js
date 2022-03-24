
import Counter from './Components/Counter';
const { Component, render } = wp.element;
render(<Counter />, document.getElementById( 'mango-counter' ) );

const Hello = () => <p>Hello WP! React here, with JSX.</p>;
wp.element.render(<Hello />, document.getElementById( 'entry-content' ) );

class Clock extends Component {
   
    constructor(props) {
        super(props);
        this.state = { date: new Date() };
    }
   
    componentDidMount() {
        this.timerID = setInterval(
            () => this.tick(),
            1000
        );
    }
   
    componentWillUnmount() {
        clearInterval(this.timerID);
    }
   
    tick() {
        this.setState({
            date: new Date()
        });
    }
   
    render() {
        return (
            <div>
                <div> Web Component  </div>
                <h2>It is {this.state.date.toLocaleTimeString()}.</h2>
            </div>
        );
    }
}

render(
  <Clock name="Search" />,
  document.getElementById('root')
);

