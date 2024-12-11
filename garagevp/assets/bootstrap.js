// import { startStimulusApp } from '@symfony/stimulus-bundle';

// const app = startStimulusApp();
// // register any custom, 3rd party controllers here
// // app.register('some_controller_name', SomeImportedController);


import { startStimulusApp } from '@symfony/stimulus-bridge';

// Initializes Stimulus, registering controllers from controllers.json and the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!',
    true,
    /\.[jt]sx?$/
));
