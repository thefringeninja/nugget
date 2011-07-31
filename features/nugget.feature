Feature: Nuggets

Scenario:
    Given a nugget "Test"
    Then the module path should equal "/test"
    And it should register routes
    And it should register routes with parameters
    And it should route the action
    And it should route the action based on the verb

Scenario: Conventional inheritance
    Given a nugget "TestSubclass"
    Then it should inherit helpers from its parent class
    And it should inherit components from its parent class