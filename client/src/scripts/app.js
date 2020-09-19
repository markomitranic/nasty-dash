import 'bootstrap';
import TotalApiAdapter from "./Total/TotalApiAdapter";
import moment from "moment";
import ErrorPopup from "./ErrorPopup";
import Form from "./Aggregate/Form";

const errorPopup = new ErrorPopup();
const apiAdapter = new TotalApiAdapter();


function test() {
	apiAdapter.resolve(
		'year',
		moment(597352400),
		moment(1597525200),
		(data, err) => {
			if (err) {
				errorPopup.add(err.message);
				return;
			}
			console.log(data);
			errorPopup.add(data.data, 'success');
		}
	)
}
const form = new Form(document.getElementById('aggregate-form'), test);
form.submit();
