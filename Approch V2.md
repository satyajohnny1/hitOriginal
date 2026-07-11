# Approach V2

## Goal

Replace pure random shooting outcomes with a lightweight, user-driven movie planning flow.

The user should not type full scenes during shooting. Instead, they should provide:

- One bounded story line before shooting starts
- Five small scene choices for the movie structure

This keeps the game fast, reduces irritation, and still makes the result feel tied to the user's decisions.

## Core Idea

The movie is broken into five fixed beats:

1. Intro
2. First Half
3. Interval Block
4. Second Half
5. Climax

Before shooting begins, the user enters a short movie premise. Then, for each beat, the user selects a compact scene card or a few low-effort options instead of writing long text again.

The system scores these choices and turns them into movie quality, opening strength, and final hit/flop result.

## Why This Works

- User input stays small
- The game feels interactive
- The movie result becomes understandable
- Copy-paste cheating is reduced
- The existing five-stage structure in the codebase can be reused

## User Flow

### Step 1: Story Premise

Before shooting starts, ask the user for one bounded story line.

Constraints:

- Minimum: 200 characters
- Maximum: 500 characters
- One text box only

Purpose:

- Captures the movie's central idea
- Sets the base theme for the rest of the movie
- Gives the scoring engine context for the scenes

### Step 2: Five Scene Choices

For each of the five movie beats, ask the user to make one compact choice.

Recommended input style:

- Scene card
- Mood
- Intensity

Example:

- Intro: family / positive / medium
- First Half: romance / warm / high
- Interval Block: twist / dark / high
- Second Half: conflict / tense / high
- Climax: victory / intense / very high

The user should tap options, not retype full scenes.

## Scene Cards

Use a fixed list of scene cards so the user only chooses, not writes.

Suggested cards:

- Action
- Emotion
- Comedy
- Romance
- Twist
- Revenge
- Mystery
- Mass Moment
- Sacrifice
- Victory

These cards can be filtered by movie beat.

## Scoring Model

The score should come from several simple layers.

### 1. Story Fit

Check whether the selected scene card matches the base story premise.

Examples:

- A revenge story should score better with revenge, conflict, and sacrifice cards
- A family drama should score better with emotion, bonding, and sacrifice cards

### 2. Beat Fit

Each beat should have cards that make sense for that part of the movie.

Examples:

- Intro: setup, emotion, family, discovery
- First Half: development, romance, fun, conflict
- Interval Block: twist, reveal, shock, betrayal
- Second Half: struggle, chase, emotion, comeback
- Climax: fight, sacrifice, victory, emotional payoff

If the user chooses a card that fits the beat, give a higher score.

### 3. Continuity

Score whether the five choices feel like a real movie progression.

Good flow example:

- Intro -> family
- First Half -> romance
- Interval -> twist
- Second Half -> conflict
- Climax -> sacrifice/victory

Bad flow example:

- Intro -> climax
- Interval -> comedy
- Second Half -> setup

### 4. Crew Bonus

Use the existing cast and crew ratings already stored in the database.

If the selected crew is strong for the chosen story type, add bonus points.

Examples:

- Strong actor + emotion scene = bonus
- Strong director + twist scene = bonus
- Strong music + climax scene = bonus

### 5. Budget Bonus

Use current spending and remaining budget to influence quality.

Higher investment can improve scene quality, but should not guarantee success.

### 6. Anti-Cheat Penalty

If the user simply copies the story line back word for word, apply a low score.

Rule:

- Exact or near-exact copy = low score
- Same meaning, rewritten naturally = better score

This discourages copy-paste while still allowing honest rephrasing.

## Recommended Scoring Behavior

Use a weighted model:

- Story fit: 25%
- Beat fit: 25%
- Continuity: 20%
- Crew bonus: 20%
- Budget bonus: 10%

Then convert the total into a 1 to 10 rating for each beat.

Suggested result bands:

- 0 to 3: weak
- 3 to 5: average
- 5 to 7: good
- 7 to 8.5: strong
- 8.5 to 10: excellent

## Final Movie Rating

After all five scene ratings are computed:

- Take a weighted average
- Give more weight to Climax and Interval Block
- Use the total as the movie's final rating

Suggested weights:

- Intro: 10%
- First Half: 20%
- Interval Block: 20%
- Second Half: 20%
- Climax: 30%

This makes the climax matter most, which matches how movies usually work.

## Final Hit/Flop Logic

Use the final rating to decide the result band.

Example:

- Below 2.0: disaster
- 2.0 to 2.75: flop
- 2.75 to 3.25: below average
- 3.25 to 3.75: average
- 3.75 to 4.25: above average
- 4.25 to 4.75: hit
- 4.75 to 5.25: super hit
- 5.25 and above: blockbuster or industry hit

The exact thresholds can be tuned later.

## Low-Input UX Recommendation

To keep the user experience light:

- Ask for story line once
- For each scene, show 3 to 5 scene cards
- Do not require full text re-entry
- Provide one-tap choices for mood and intensity

This is the best balance between control and simplicity.

## Suggested Data Storage

The current codebase already has a five-stage structure, so this approach can fit cleanly.

Recommended storage options:

### Option A: Extend the existing movie record

Add fields to the movie/shoot table for:

- story_line
- intro_card
- first_half_card
- interval_card
- second_half_card
- climax_card
- tone values
- intensity values

### Option B: Add a small companion table

Store the story and the five scene choices in a separate table linked by `uid` and `rid`.

This is cleaner if you want to keep the main movie table smaller.

## Suggested File Touch Points

- `readyforshoot.php`
- `shooting.php`
- `ratingAjax.php`
- `addcenters.php`
- `shootingAjax.php`

## Implementation Order

1. Add story premise input before shooting
2. Add 5 scene card choices
3. Compute scene score from story + card + beat
4. Remove pure random scoring from shooting
5. Use weighted final rating for hit/flop
6. Tune thresholds after playtesting

## Summary

This approach gives the user control without making them write long text repeatedly.

It is:

- low friction
- movie themed
- easy to explain
- compatible with the current PHP codebase
- better than random-only scoring

It also creates a stronger gameplay loop because the user can see how their early creative choices affect the final movie result.

## Approach 2: Better Low-Input Alternatives

If the five-scene text input still feels too heavy, use one of these lighter options.

### 1. Story Blueprint Sliders

Ask for one bounded story line once, then let the user tune five sliders.

Suggested sliders:

- Emotion
- Action
- Comedy
- Twist
- Mass Appeal

This is the lowest-friction option because the user only adjusts values instead of writing text.

### 2. Beat Card Selection

For each of the five beats, show 4 to 5 scene cards and let the user tap one.

Example cards:

- Intro: family, action, love, mystery
- First Half: romance, fun, conflict, travel
- Interval Block: twist, shock, betrayal, chase
- Second Half: struggle, comeback, revenge, emotion
- Climax: victory, sacrifice, fight, tragedy

This is the cleanest option for gameplay and easiest to understand.

### 3. One Keyword Per Scene

Ask the user to enter only one keyword for each beat.

Examples:

- Intro: family
- First Half: romance
- Interval Block: betrayal
- Second Half: revenge
- Climax: sacrifice

This gives enough signal for scoring while keeping typing minimal.

### 4. Director Intent Path

Instead of scene writing, ask the user what the director wants to do in each beat.

Options:

- Keep it safe
- Build emotion
- Add a twist
- Increase action
- Go for climax

This feels realistic because it is how film planning often works.

### 5. Audience Test Choice

After each beat, show a simple test question:

- Should this be more emotional?
- Should we add a bigger twist?
- Should we make it mass-friendly?

This makes the player feel like they are shaping the movie with audience feedback.

## Approach 2 Recommendation

Best practical version for this codebase:

1. Ask one short story line
2. For each of the five beats, use beat cards
3. Add one intensity selector per beat
4. Score the movie using story fit, beat fit, continuity, crew bonus, and budget bonus

This keeps input small, avoids irritation, and still gives the user meaningful control over the movie outcome.

## Approach 3: Hybrid 2 Text + 3 Visual

This version mixes two small text inputs with three visual/clickable inputs.

### Why This Is Better

- Less typing
- More movie-like
- Easier for mobile users
- Feels interactive
- Still gives enough signal for scoring

### Inputs

#### Text Input 1: Story Line

Ask for one bounded movie premise before shooting starts.

Constraints:

- 200 to 500 characters
- One paragraph only

Purpose:

- Sets the base narrative
- Drives the scoring engine
- Gives context for all scene cards

#### Text Input 2: Tone or Intent

Ask one short text field for the film's overall mood or intent.

Examples:

- Family drama
- Mass action entertainer
- Emotional revenge story
- Romantic comedy
- Thriller with a twist

This is a small second input that helps the system understand what kind of movie the user wants to make.

#### Visual Input 1: Intro Card

User taps a visual card for the opening tone of the movie.

Examples:

- Family setup
- Hero introduction
- Mystery setup
- Love track
- Action intro

#### Visual Input 2: Interval Block Card

User taps a visual card for the big turning point.

Examples:

- Twist reveal
- Betrayal
- Sudden loss
- Hero setback
- Major chase

#### Visual Input 3: Climax Card

User taps a visual card for the final payoff.

Examples:

- Victory
- Sacrifice
- Emotional win
- Mass fight
- Tragic ending

### UI Flow

#### Screen 1: Story Setup

Show:

- Title
- Story line textarea
- Tone/intent text input
- Continue button

Goal:

- Capture the movie's core idea in two small inputs

#### Screen 2: Visual Beat Picker

Show a five-step timeline:

- Intro
- First Half
- Interval Block
- Second Half
- Climax

For the first, third, and fifth slots, show clickable cards.

For the other two slots:

- Either auto-fill based on story + previous picks
- Or show simplified buttons like `safe`, `balanced`, `bold`

#### Screen 3: Review and Confirm

Show a summary:

- Story line
- Tone
- Selected beat cards
- Estimated quality
- Estimated hit/flop range

User taps `Confirm Shooting` to begin the shooting flow.

### Randomization Rules

Randomize only the presentation, not the meaning.

Good randomization:

- Shuffle the card order
- Shuffle which icon appears on the card
- Rotate the card layout slightly

Bad randomization:

- Changing the actual category unexpectedly
- Making the scoring unpredictable

### Scoring Model for Approach 3

Use the same weighted structure as Approach 2, but give extra weight to visual beat selection.

Suggested weights:

- Story fit: 20%
- Tone fit: 15%
- Visual beat fit: 30%
- Continuity: 15%
- Crew bonus: 15%
- Budget bonus: 5%

This version works well because the user makes fewer text decisions, but each visual pick still has real impact.

### Implementation Notes

Best place to add this flow:

- `readyforshoot.php`

Recommended storage:

- Story line field
- Tone field
- Intro card field
- Interval card field
- Climax card field

Recommended UI components:

- Text area for story
- Small text input for tone
- Bootstrap cards or buttons for visual selections
- One confirm button at the end

### Best Use Case

Approach 3 is best when you want:

- Low typing
- Good mobile usability
- Simple scoring
- Clear user choices
- A stronger visual feel than plain form inputs
