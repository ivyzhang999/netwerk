Authors: Brady Schaer and Ivy Zhang

Product: Netwerk

Description: Netwerk is a social networking tool meant as a combination of LinkedIn and Tinder. 
Users can visit Netwerk, create profiles (For either a job or as a candidate), login, and view the opposite kinds of profiles on the main screen (i.e a candidate views other jobs)
The user then can swipe left or right on a given profile, with a right swipe meaning yes and a left swipe meaning no. 
If two profiles swipe right on each other, they "match" and will appear on the matches section of the website.

Link: http://ec2-52-14-187-234.us-east-2.compute.amazonaws.com/~ivy.zhang/index2.html

Example sign in: 

for a Candidate: 

User: lebron

PW: lebron

for a Company: 

User:wonka 

PW: wonka

Creative protion:

1. Sound effects: When a user swipes right, a swishing sound is played. When they swipe left, a sad trombone sound is played. When a user swipes right on a profile and matches with them, a ding sound is played. We felt this was a great way to make the website more fun and interactive, while utilizing a skill not yet used in the course.

2. Recommended jobs from outside the website database for candidate profiles: We added a feature in the my profile section that displays a job posting located in the users inputed desired location. We find these job listings by using GitHub jobs. We wrote a function that searches on Github jobs for a job in the desired location, returns the results as a JSON, and then selects a random job from the returned JSON to display on the candidate's profile. We wanted to add a feature that utilized an outside data source, and felt this was a good way to show how outside data can increase the amount of possible jobs a user is exposed to.

3. Recommended courses: When a user creates a profile, they mark whether they have front end, back end, or data science skills. We added a feature on the my profile section that views the listed skills of the candidate signed in, and based on which skills they did not list, makes a recommendation of a web resource to learn that skill. For example, if a candidate marked that they did not possess data science skills, Netwerk recommends a resource to start learning SQL. If a user decides they have learned enough, they can edit their profile and change their selected skills.

4. Angular Filter for currency: We added a filter when any salary info is displayed that automatically formats it to correct currency format. We thought this was a good way to show a very useful feature of angularJS in our web app.