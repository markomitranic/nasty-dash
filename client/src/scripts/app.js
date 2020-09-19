import 'bootstrap';
import NotificationPopup from "./NotificationPopup";
import TotalDashboard from "./Dashboard/TotalDashboard";
import AggregateFormDispatcher from "./Aggregate/FormDispatcher";
import TotalApiAdapter from "./Entity/Total/ApiAdapter";

const notificationPopup = new NotificationPopup();

const totalApiAdapter = new TotalApiAdapter(notificationPopup);

const aggregateFormDispatcher = new AggregateFormDispatcher(
	document.getElementById('aggregate-form'),
	totalApiAdapter
);

const totalDashboard = new TotalDashboard(totalApiAdapter);
aggregateFormDispatcher.submit(null);
