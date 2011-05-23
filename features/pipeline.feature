Feature: Pipeline

Scenario: Pre request hook returns false
    Given a nugget "Test"
        And I insert a pre request hook that returns false
    When I request a resource
    Then it should cancel execution of the route

Scenario: Pre request hook returns true
    Given a nugget "Test"
        And I insert a pre request hook that returns true
    When I request a resource
    Then it should not cancel execution of the route

Scenario: Post request hook
    Given a nugget "Test"
        And I insert a post request hook
    When I request a resource
    Then it can modify the response