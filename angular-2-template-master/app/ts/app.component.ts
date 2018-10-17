import {Component} from 'angular2/core';
import {Config} from './config.service';
import {Video} from './video';
import {PlaylistComponent} from './playlist.component';

@Component({
    selector: 'my-app',
    templateUrl: 'app/ts/app.component.html',
    directives: [PlaylistComponent]
})

export class AppComponent {
	mainHeading = Config.MAIN_HEADING;
	videos:Array<Video>;

	constructor(){
		this.videos = [
			new Video(1, "2029 : Singularity Year", "EyFYFjESkWU", "Neil deGrasse Tyson"),
			new Video(2, "Learn Angular 2 from Scratch", "_-CD_5YhJTA", "Angular 2 Tutorial")
			new Video(3, "Angular 2 Complete Course", "v=d6Dp4Dyeke8", "Sections 1 & 2")
			new Video(4, "Introduction to TypeScript ", "qRD7bkK7m10", "Typescript Tutorial")
			new Video(5, "Learn Angular 2 from Scratch", "_-CD_5YhJTA", "Angular 2 Tutorial")

		]
	}
}
