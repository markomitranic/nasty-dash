import 'bootstrap';
import NotificationPopup from "./NotificationPopup";
import TotalDashboard from "./Dashboard/TotalDashboard";
import AggregateFormDispatcher from "./Aggregate/FormDispatcher";
import TotalApiAdapter from "./API/Total/ApiAdapter";
import Spinner from "./Spinner";

// Register Utilities
const notificationPopup = new NotificationPopup();
const spinner = new Spinner(document.getElementById('ajax-loader'));
const aggregateFormDispatcher = new AggregateFormDispatcher(document.getElementById('aggregate-form'));

// Register API adapters
const totalApiAdapter = new TotalApiAdapter(notificationPopup, spinner);
aggregateFormDispatcher.addObserver(totalApiAdapter);

// Build up the router or dashboard sets
const totalDashboard = new TotalDashboard(totalApiAdapter);

// Trigger first load
aggregateFormDispatcher.submit(null);
