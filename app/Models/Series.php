<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'series';

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'destination',
    ];

    public const CATEGORY_PROMPTS = [
        'random_ai_story' => "Craft a captivating and imaginative story with an unexpected twist. The story can be set in any genre or setting, and should feature engaging characters and a compelling plot. Begin with an intriguing hook to grab the audience’s attention, and develop the narrative with surprising turns and memorable moments. The goal is to entertain and captivate the audience with a fresh and unpredictable tale.",
        'interesting_history' => "Please share a concise and captivating account of a highly interesting, yet lesser-known historical event. The event MUST be real, factual, and found on Wikipedia. Begin with a captivating introduction or question to hook the audience. Your goal is to fascinate and inform the audience on interesting history.",
        'scary_stories' => "Tell a short and spine-chilling story that will leave the audience on edge. The story should evoke fear and suspense, while being grounded in realistic settings or scenarios. Start with an eerie introduction, then slowly build tension, leading to a terrifying and unexpected climax. Ensure the story is appropriate for a broad audience but still unsettling.",
        'bedtime_stories' => "Craft a gentle and soothing bedtime story that will help the audience wind down for the night. The story should be calm, imaginative, and have a peaceful resolution. Begin with a warm and inviting introduction, and guide the audience through a serene journey that promotes relaxation and comfort. The tone should be soft and calming, perfect for a restful night’s sleep.",
        'urban_legends' => "Share a captivating urban legend that has been passed down through generations, blending mystery and fear. The story should evoke a sense of wonder and uncertainty, often blurring the lines between truth and myth. Begin with an intriguing introduction, presenting the legend as something that could be real, then unfold the eerie tale with a focus on suspense and the unknown. Leave the audience questioning the truth behind the legend.",
        'motivational' => "Deliver an inspiring and uplifting message designed to motivate the audience. The story or message should center around overcoming challenges, achieving goals, or personal growth. Begin with a powerful introduction that captures attention, then guide the audience through an encouraging narrative or thought-provoking concept. The goal is to inspire positivity, resilience, and a strong belief in one’s ability to succeed.",
        'fun_facts' => "Share a collection of fascinating and quirky facts that are sure to surprise and delight the audience. Each fact should be unique, engaging, and interesting, with enough context to make it memorable. Start with a fun and curious tone, encouraging the audience to learn something new and unexpected. The goal is to entertain while educating with light-hearted and intriguing facts.",
        'long_form_jokes' => "Tell a well-structured and humorous long-form joke that gradually builds up to a clever punchline. The joke should have a clear narrative, with funny twists and turns along the way. Start with an engaging setup that pulls the audience in, then keep the humor flowing as you slowly escalate towards a surprising and satisfying conclusion. The goal is to keep the audience entertained throughout and leave them laughing by the end.",
        'life_pro_tips' => "Share practical and actionable life pro tips that can help the audience improve various aspects of their daily lives. Each tip should be simple, effective, and easy to implement, covering areas like productivity, self-care, organization, or problem-solving. Begin with a clear and concise introduction to the tip, explaining why it’s useful, and then provide step-by-step guidance on how to apply it. The goal is to offer helpful advice that makes life easier or more efficient.",
        'philosophy' => "Present a thought-provoking philosophical concept or question that encourages the audience to reflect deeply on life, existence, or morality. Start with a captivating introduction that introduces a fundamental idea or dilemma from a major school of thought, then guide the audience through various perspectives or interpretations. The goal is to challenge the audience’s thinking, foster curiosity, and spark meaningful reflection or discussion.",
        // 'product_marketing' => "Create a compelling and persuasive marketing message that highlights the key features and benefits of a product. Start with an attention-grabbing introduction that addresses a common problem or need, then present the product as the perfect solution. Focus on the unique selling points, and include a call-to-action that encourages the audience to take the next step, whether it's learning more or making a purchase. The goal is to create excitement and convince the audience of the product's value.",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function currentVideo()
    {
        return $this->videos()->where('is_current', true)->first();
    }

    public function pastVideos()
    {
        return $this->videos()->where('is_current', false)->get();
    }
}
