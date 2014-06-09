SuperModel is a PHP tool for defining data models at run time.

Most data modelling tools for PHP are tightly coupled to the database APIs they are tied to. Others are rigid, and can't be changed at runtime. SuperModel provides an API for defining a data model which is only generated when it is accessed. This allows the model to be altered, even during a request if necessary.

SuperModel makes no assumptions about your data source, storage, output or other components, and can be easily tied into other systems.

## Usage

SuperModel assumes you will create a new Class to define your model that extends the SuperModel.

While SuperModel allows you to define things like whether a property is required, or changeable, it does not validate whether these properties are changed.