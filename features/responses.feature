Feature: Responses

Scenario: Returns an integer
    Given a nugget "Test"
    When I request "/test/returns/code/404"
    Then the response code should be 404

Scenario: Returns a bare model
    Given a nugget "Test"
    When I request "/test/returns/model"
    Then the response code should be 200
        And the response model should not be null

Scenario: Renders a cakephp view
    Given a nugget "Test"
    When I request "/test/returns/view"
    Then the response code should be 200
        And the response model should not be null
        And it should render the view