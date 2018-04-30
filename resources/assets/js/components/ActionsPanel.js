import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class ActionsPanel extends Component {
    render() {
        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <div className="btn-group">
                        <button onClick={this.setTool.bind(this, 'npc')} className="btn btn-primary btn-sm">NPC</button>
                        <button onClick={this.setTool.bind(this, 'warp')} className="btn btn-primary btn-sm">Warp</button>
                        <button onClick={this.setTool.bind(this, 'enemy')} className="btn btn-primary btn-sm">Enemy</button>
                        <button onClick={this.setTool.bind(this, 'trigger')} className="btn btn-primary btn-sm">Trigger</button>
                    </div>
                    <button className="btn btn-primary btn-sm">Quest log</button>
                </div>
            </div>
        );
    }

    setTool(tool) {
        window.selectedTool = tool;
    }
}

$('ActionsPanel').each(function (i, el) {
    ReactDOM.render(<ActionsPanel />, el);
});
