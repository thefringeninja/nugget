Feature: Modules

Scenario:
    Given a module "Test"
    Then the module path should equal "/test"
    And it should register routes
    And it should register routes with parameters
    And it should route the action
    And it should route the action based on the verb