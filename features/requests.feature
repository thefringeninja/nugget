Feature: Requests

Scenario: Returns an integer
    Given a nugget "Test"
    When the "Accept" header is "text/html"
        And I request "/test/returns/request?q=1"
    Then the "Accept" header should be "text/html"
        And the request method should be "GET"
        And the request uri path should be "/test/returns/request"
        And the request query string "q" should be "1"